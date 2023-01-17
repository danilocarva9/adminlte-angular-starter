import { AuthInterceptor } from './core/interceptor/auth.interceptor';
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ReactiveFormsModule } from '@angular/forms';
import { JwtHelperService, JWT_OPTIONS  } from '@auth0/angular-jwt';

import { AuthGuard } from './core/guard/auth.guard';
import { HeaderComponent } from './pages/private/shared/header/header.component';
import { FooterComponent } from './pages/private/shared/footer/footer.component';
import { SideMenuComponent } from './pages/private/shared/side-menu/side-menu.component';
import { DashboardComponent } from './pages/private/dashboard/dashboard.component';
import { LoginComponent } from './pages/public/login/login.component';
import { ForgotPasswordComponent } from './pages/public/forgot-password/forgot-password.component';
import { RegisterComponent } from './pages/public/register/register.component';
import { RecoveryPasswordComponent } from './pages/public/recovery-password/recovery-password.component';
import { SideBarComponent } from './pages/private/shared/side-bar/side-bar.component';
import { ProfileComponent } from './pages/private/profile/profile.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    SideMenuComponent,
    DashboardComponent,
    LoginComponent,
    ForgotPasswordComponent,
    RegisterComponent,
    RecoveryPasswordComponent,
    SideBarComponent,
    ProfileComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule
  ],
  providers: [
    AuthGuard,
    { 
      provide: JWT_OPTIONS,
      useValue: JWT_OPTIONS 
    },
      JwtHelperService,
    { 
      provide: HTTP_INTERCEPTORS, 
      useClass: AuthInterceptor, 
      multi: true
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
