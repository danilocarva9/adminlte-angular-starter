import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/core/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {

  loginForm: any = FormGroup;
  loading = false;
  submitted = false;
  errorMessage = [];
  userInfo = [];

  constructor(
    private router: Router,
    private FormBuilder: FormBuilder,
    private authService: AuthService
  ) { 
   
  }

  ngOnInit(): void {
    this.loginForm = this.FormBuilder.group({
       email: ['', Validators.required],
       password: ['', Validators.required]
    });

    console.log('user logged? '+this.authService.isAuthenticated());
  }

  // get to return form fields
  get form() { return this.loginForm.controls; }

  onSubmit(){
    console.log('submeteu');
    this.submitted = true;

    //Stop if the form is invalid
    if(this.loginForm.invalid){
      console.log('form invalid');
      return;
    }

    this.loading = true;

    this.authService.login(this.form.email.value, this.form.password.value)
      .subscribe({
        next: (res) =>  {
          this.loading = false;
          if(this.authService.isAuthenticated()){
            this.router.navigate(['/dashboard']);
          }
        },
        error: (err) => {
          console.log('error: '+JSON.stringify(err.error.message));
          this.errorMessage = err.error.message;
          this.loading = false;
        }
      });
    
  }

}
