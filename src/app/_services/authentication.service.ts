import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/throw';
import 'rxjs/add/operator/map'

@Injectable()
export class AuthenticationService {
    public token: string;

    constructor(private http: Http) {
        // set token if saved in local storage
        var currentUser = JSON.parse(localStorage.getItem('currentUser'));
        this.token = currentUser && currentUser.token;
    }
    


    login(username: string, password: string): Observable<string> {
    var headers = new Headers();
    headers.append('Content-Type', 'application/x-www-form-urlencoded');
        
    let urlSearchParams = new URLSearchParams();
    urlSearchParams.append('email', username);        
    urlSearchParams.append('password', password);
        
    let body = urlSearchParams.toString();
        
    return this.http.post('http://localhost:8000/api/auth/login', body, {headers:headers})
            .map((response: Response) => {
                // login successful if there's a jwt token in the response
                let token = response.json() && response.json().token;
                let msg = response.json().message;
                if (token) {
                    // set token property
                    this.token = token;
                        
                    
                    // store username and jwt token in local storage to keep user logged in between page refreshes
                    localStorage.setItem('currentUser', JSON.stringify({ username: username, token: token }));

                    // return true to indicate successful login
                    return msg;
                } else {
                    // return false to indicate failed login
                    return msg;
                }
            }).catch((error:any) => Observable.throw(error.status || 'Server error'));;
    }

    logout(): void {
        // clear token remove user from local storage to log user out
        this.token = null;
        localStorage.removeItem('currentUser');
    }
}