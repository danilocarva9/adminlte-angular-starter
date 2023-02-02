import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Constants } from 'src/app/config/constants';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  private apiUrl;
  
  constructor(
    private httpClient: HttpClient,
  ){ 
    this.apiUrl = Constants.API_ENDPOINT;
  }
 

  getUserById(userId: number): Observable<any> {
    return this.httpClient.get(`${this.apiUrl}users/${userId}/profile`).pipe(map((userInfo: any) => {
        return userInfo;
    }));
  }

  saveProfile(formData: any):Observable<any> {
     return this.httpClient.post(`${this.apiUrl}users/profile`, formData).pipe(map((userProfile: any) => {
        return userProfile;
     }));
  }
  
}
