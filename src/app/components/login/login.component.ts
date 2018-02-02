import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { AuthenticationService } from '../../_services/index';

@Component({
    moduleId: module.id,
    templateUrl: 'login.component.html',
    styleUrls: ['./login.component.scss']
})

export class LoginComponent implements OnInit {
    model: any = {};
    loading = false;
    error = '';

    constructor(
        private router: Router,
        private authenticationService: AuthenticationService) { }

    ngOnInit() {
        // reset login status
        this.authenticationService.logout();
    }

    login() {
        this.loading = true;
        this.authenticationService.login(this.model.username, this.model.password)
            .subscribe(result => {
                if (result === 'token_generated') {
                    this.router.navigate(['/']);
                } else {
                    this.error = result;
                    this.loading = false;
                }
            },error => {
                    
                    if(error===401){
                        this.error = 'Invalid Credential';    
                    }
                    else if(error===422){
                        this.error = 'Incorect email address';    
                    }
                    else
                    {
                        this.error= 'Failed to login';
                    }
                    
                    this.loading = false;
                    console.log(error)
              });
    }
}
