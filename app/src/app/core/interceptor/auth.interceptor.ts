import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { AuthService } from '../services/auth.service';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

constructor(private authService:AuthService){}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {

        const token = this.authService.getData('token');

        if(token == null){
            return next.handle(request);
        }
    
        const req = request.clone({
            setHeaders: {
                'Authorization' : `Bearer ${token}`
            }
        });

        return next.handle(req);
    }
}