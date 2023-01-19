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
 

  saveProfile(profileInfo: any):Observable<any> {
     return this.httpClient.patch(this.apiUrl+'users/3/profile', profileInfo).pipe(map((userProfile: any) => {
        return userProfile;
     }));
  }
  
}
