import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Constants } from 'src/app/config/constants';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {

  private apiUrl;
  

  constructor(
    private httpClient: HttpClient
  ) { 
    this.apiUrl = Constants.API_ENDPOINT;
  }
 

  saveProfile(formData: any):Observable<any> {
     return this.httpClient.post(this.apiUrl+'users/3/profile', formData).pipe(map((userProfile: any) => {
        return userProfile;
     }));
  }
  
}
