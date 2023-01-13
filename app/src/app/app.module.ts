import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ReactiveFormsModule } from '@angular/forms';
import { JwtHelperService, JWT_OPTIONS  } from '@auth0/angular-jwt';

import { AuthGuard } from './core/auth/auth.guard';
import { HeaderComponent } from './pages/private/shared/header/header.component';
import { FooterComponent } from './pages/private/shared/footer/footer.component';
import { SideMenuComponent } from './pages/private/shared/side-menu/side-menu.component';
import { DashboardComponent } from './pages/private/dashboard/dashboard.component';
import { LoginComponent } from './pages/public/login/login.component';
import { ForgotPasswordComponent } from './pages/public/forgot-password/forgot-password.component';
import { RegisterComponent } from './pages/public/register/register.component';
import { RecoveryPasswordComponent } from './pages/public/recovery-password/recovery-password.component';
import { SideBarComponent } from './pages/private/shared/side-bar/side-bar.component';

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
    SideBarComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule
  ],
  providers: [
    AuthGuard,
    { provide: JWT_OPTIONS, useValue: JWT_OPTIONS },
      JwtHelperService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
