import { UserService } from 'src/app/core/services/user/user.service';
import { ProfileService } from 'src/app/core/services/user/profile.service';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/core/services/auth.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent {

  profileForm: any = FormGroup;
  loading = false;
  submitted = false;
  errorMessage = [];
  user: any = {};
  profile: any = {};

  selectedFiles?: FileList;
  currentFile?: File;
  message = '';
  preview = '';

  constructor(
    private FormBuilder: FormBuilder,
    private profileService: ProfileService,
    private authService: AuthService,
    private userService: UserService
  ){
    this.user = this.authService.getAuthUserInfo();
  }

  ngOnInit(): void {
    this.profileForm = this.FormBuilder.group({
      name: ['', Validators.required],
      role: ['', Validators.required],
      description: ['', Validators.required],
      picture: [null]
    });
    this.loadUserProfile(this.user.id);
  }


  private loadUserProfile(userId: number)
  {
    this.userService.getUserById(userId)
      .subscribe({
          next: (user) =>  {
            this.profileForm.patchValue({
              name: user.data.name,
              role: user.data.profile.role,
              description: user.data.profile.description,
              picture: user.data.profile.picture
            })
          },
          error: (err) => {
            console.log('error: '+JSON.stringify(err.error.message));
            this.errorMessage = err.error.message;
          }
    });
  
  }

  // Get to return form fields
  get form() { return this.profileForm; }

  onSubmit(){

    this.submitted = true;
    //Stop if the form is invalid
    if(this.form.invalid){
      return;
    }
    //Set form data
    const formdata: FormData = new FormData();
    //Get all form values
    let formValues = this.form.getRawValue();

    for(let key in formValues){
      formdata.append(key, formValues[key]);
    }
    //Add user to data
    formdata.append('user_id', this.user.id);
    //If has user picture
    if(this.selectedFiles){
      const file: File | null = this.selectedFiles.item(0);
      if(file){
        this.currentFile = file;
        formdata.append('picture', this.currentFile);
      }
    }
    
    this.profileService.saveProfile(formdata)
      .subscribe({
          next: (res) =>  {
            this.loading = false;
          },
          error: (err) => {
            console.log('error: '+JSON.stringify(err.error.message));
            this.errorMessage = err.error.message;
            this.loading = false;
          }
    });
  }

  //Select and show preview of the picture
  selectFile(event: any): void {
    this.message = '';
    this.preview = '';
    this.selectedFiles = event.target.files;

    if(this.selectedFiles) {
      const file: File | null = this.selectedFiles.item(0);

      if(file){
        this.preview = '';
        this.currentFile = file;

        const reader = new FileReader();

        reader.onload = (e: any) => {
          this.preview = e.target.result;
          console.log(e.target.result);
        }
       // console.log(this.currentFile);
        reader.readAsDataURL(this.currentFile);
      }
    }
  }


}
