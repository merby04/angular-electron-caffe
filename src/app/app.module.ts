import 'zone.js/dist/zone-mix';
import 'reflect-metadata';
import 'polyfills';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppComponent } from './app.component';

import { AppRoutingModule } from './app-routing.module';

import { ElectronService } from './providers/electron.service';

import { AuthGuard } from './_guards/index';
import { AuthenticationService, UserService } from './_services/index';
import { LoginComponent } from './components/login/index';
import { HomeComponent } from './components/home/index';
import { DBService} from './_services/db.service';
import { BsDropdownModule } from 'ngx-bootstrap';
import {  SharedModule,  FooterComponent,  HeaderComponent, } from './shared';


@NgModule({
  declarations: [
    FooterComponent,
    HeaderComponent,
    AppComponent,
    HomeComponent,
    LoginComponent
  ],
  imports: [      
    BsDropdownModule.forRoot(),
    SharedModule,
    BrowserModule,
    FormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [
      ElectronService,
      AuthGuard,
      AuthenticationService,
      UserService,
      DBService
    ],
  bootstrap: [AppComponent]
})
export class AppModule { }
