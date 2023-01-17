import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Constants } from 'src/app/config/constants';

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
    this.tokenKey = 'token';
  }

  register(registerData: []):Observable<any> {
    return this.httpClient.post(this.apiUrl+'register', registerData);
  }

  login(email: string, password: string):Observable<any> {
     return this.httpClient.post(this.apiUrl+'login', {email, password}).pipe(map((user: any) => {
      if(user.data.access_token){
          this.setToken(user.data.access_token);
        }
        return user;
     }));
  }

  logout(): void
  {
    localStorage.removeItem(this.tokenKey);
  }

  isAuthenticated(): Boolean
  {
    const token = this.getToken();
    return !this.jwtHelper.isTokenExpired(token);
  }

  setToken(token: string): void
  {
    localStorage.setItem(this.tokenKey, token);
  }

  getToken()
  {
    return localStorage.getItem(this.tokenKey);
  }

 
  
}
