import { ProfileService } from 'src/app/core/services/user/profile.service';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

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

  selectedFiles?: FileList;
  currentFile?: File;
  message = '';
  preview = '';

  constructor(
    private FormBuilder: FormBuilder,
    private profileService: ProfileService
  ){}

  ngOnInit(): void {
    this.profileForm = this.FormBuilder.group({
      name: ['', Validators.required],
      role: ['', Validators.required],
      description: ['', Validators.required]
    });
  }

   // get to return form fields
  // get form() { return this.profileForm.controls; }
  get form() { return this.profileForm; }

  onSubmit(){

    this.submitted = true;
    //Stop if the form is invalid
    if(this.form.invalid){
      console.log('form invalid');
      return;
    }
    //Get all form values
    
    this.form.get('picture');
    let formValues = this.form.getRawValue();

    //If has user picture
    if(this.selectedFiles){
      const file: File | null = this.selectedFiles.item(0);
      if(file){
        this.currentFile = file;
        formValues.picture = this.currentFile;
      }
    }
    
    this.profileService.saveProfile(formValues)
      .subscribe({
          next: (res) =>  {
          this.loading = false;
            console.log(res);
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
