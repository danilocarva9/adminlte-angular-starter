import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/core/services/auth.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {

  loginForm: any = FormGroup;
  loading = false;
  submitted = false;
  error = false;
  errorMessage = [];
  userInfo = [];

  constructor(
    private FormBuilder: FormBuilder,
    private authService: AuthService
  ) { 
   
  }

  ngOnInit(): void {
    this.loginForm = this.FormBuilder.group({
       email: ['', Validators.required],
       password: ['', Validators.required]
    });
  }

  // get to return form fields
  get form() { return this.loginForm.controls; }

  onSubmit(){
    console.log('submeteu');
    this.submitted = true;

    //Stop if the form is invalid
    if(this.loginForm.invalid){
      console.log('form invalid');
      this.error = true;
      return;
    }

    this.loading = true;


    this.authService.login(this.form.email.value, this.form.password.value)
      .subscribe({
        next: (res) =>  {
          console.error('Userinfo: '+JSON.stringify(res)); //this.userInfo = res,
        },
        error: (err) => {
          console.log('error: '+JSON.stringify(err.error.status));
          this.error = true;
          this.errorMessage = err.error.message;
          this.loading = false;
        }
      });
    
  }

}
