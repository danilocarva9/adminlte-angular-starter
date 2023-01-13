import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';



@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl;

  constructor(
    private httpClient: HttpClient
  ) { 
    this.apiUrl = 'http://localhost:8000/';
  }

  register(registerData: []):Observable<any> {
    return this.httpClient.post(this.apiUrl+'register', registerData);
  }

  login(email: string, password: string):Observable<any> {
     return this.httpClient.post(this.apiUrl+'login', {email, password}).pipe(map((user: any) => {
        if(user.data.access_token){
          localStorage.setItem('token', user.data.access_token);
        }
        return user;
     }));
  }

  
}
