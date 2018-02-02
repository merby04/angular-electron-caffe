
import { Component, OnInit } from '@angular/core';
import { DBService } from '../../_services/db.service';
import { User } from '../../_models/index';
import { UserService } from '../../_services/index';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/throw';
import 'rxjs/add/operator/map'

@Component({
    moduleId: module.id,
    templateUrl: 'home.component.html'
})

export class HomeComponent implements OnInit {
    users: User[] = [];
    keys: String[];

    constructor(private userService: UserService,private db: DBService) { }
    
    

    ngOnInit() {
        // get users from secure api end point
        /*
        this.userService.getUsers()
            .subscribe(users => {
                this.users = users;
            });
            */
        //this.users =  this.db.query('SELECT * FROM users');
        
            
    }



}