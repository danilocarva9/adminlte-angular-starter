import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Constants } from 'src/app/config/constants';
import { AuthService } from '../auth.service';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {

  private apiUrl;
  user: any = {};
  
  constructor(
    private httpClient: HttpClient,
    private authService: AuthService
  ) { 
    this.apiUrl = Constants.API_ENDPOINT;
    this.user = this.authService.getAuthUserInfo();
  }
 
  saveProfile(formData: any):Observable<any> {
     
     return this.httpClient.post(`${this.apiUrl}users/${this.user.id}/profile`, formData).pipe(map((userProfile: any) => {
        return userProfile;
     }));
  }
  
}
