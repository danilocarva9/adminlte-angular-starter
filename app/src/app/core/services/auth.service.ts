import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Constants } from 'src/app/config/constants';
import * as CryptoJS from 'crypto-js';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl;
  private tokenKey: string;

  constructor(
    private jwtHelper: JwtHelperService,
    private httpClient: HttpClient
  ) { 
    this.apiUrl = Constants.API_ENDPOINT;
    this.tokenKey = 'chaveSecretaToken123';
   
  }

  register(registerData: []):Observable<any> {
    return this.httpClient.post(this.apiUrl+'register', registerData);
  }

  login(email: string, password: string):Observable<any> {
     return this.httpClient.post(this.apiUrl+'login', {email, password}).pipe(map((user: any) => {
       if(user.data.access_token){
          this.setData('token', user.data.access_token);
        }
        return user;
     }));
  }

  logout(): void
  {
    localStorage.removeItem('token');
  }

  getAuthUserInfo(): object {
    const token = this.getData('token');
    const userInfo = this.jwtHelper.decodeToken(token);
    return userInfo.user;
  }

  isAuthenticated(): Boolean
  {
    const token = this.getData('token');
    return !this.jwtHelper.isTokenExpired(token);
  }

  setData(key: string, data: string): void {
    localStorage.setItem(key, this.encrypt(data));
  }

  getData(value: string): string {
    let data = localStorage.getItem(value) || "";
    return this.decrypt(data);
  }

  private encrypt(value: string): string {
    return CryptoJS.AES.encrypt(value, this.tokenKey).toString();
  }

  private decrypt(value: string): string {
    return CryptoJS.AES.decrypt(value, this.tokenKey).toString(CryptoJS.enc.Utf8);
  }

 
  
}
