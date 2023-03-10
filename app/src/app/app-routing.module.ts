import { ProfileComponent } from './pages/private/profile/profile.component';
import { DashboardComponent } from './pages/private/dashboard/dashboard.component';
import { RecoveryPasswordComponent } from './pages/public/recovery-password/recovery-password.component';
import { RegisterComponent } from './pages/public/register/register.component';
import { ForgotPasswordComponent } from './pages/public/forgot-password/forgot-password.component';
import { LoginComponent } from './pages/public/login/login.component';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from './core/guard/auth.guard';

const routes: Routes = [
  { path: '', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  { path: 'forgot-password', component: ForgotPasswordComponent },
  { path: 'recovery-password', component: RecoveryPasswordComponent },
  { 
    path: '', canActivate: [AuthGuard],
    children: [
      { path: 'dashboard', component: DashboardComponent },
      { path: 'profile', component: ProfileComponent }
    ]
  }

  //{ path: 'dashboard', component: DashboardComponent, canActivate: [AuthGuard] }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
