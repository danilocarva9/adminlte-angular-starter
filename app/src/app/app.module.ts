import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './pages/private/shared/header/header.component';
import { FooterComponent } from './pages/private/shared/footer/footer.component';
import { SideMenuComponent } from './pages/private/shared/side-menu/side-menu.component';
import { DashboardComponent } from './pages/private/dashboard/dashboard.component';
import { LoginComponent } from './pages/public/login/login.component';
import { ForgotPasswordComponent } from './pages/public/forgot-password/forgot-password.component';
import { RegisterComponent } from './pages/public/register/register.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    SideMenuComponent,
    DashboardComponent,
    LoginComponent,
    ForgotPasswordComponent,
    RegisterComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
