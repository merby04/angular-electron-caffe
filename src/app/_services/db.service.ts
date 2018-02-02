import {Injectable} from '@angular/core';
const mysql = (<any>window).require('mysql');

@Injectable()
export class DBService {
    connection: any;

    constructor() {
        this.connection = mysql.createConnection({
            host: 'localhost',
            user: 'root',
            password: 'vacmackers',
            database: 'fivecode'
        });
        this.connection.connect((err) => {
           if (err) {
             console.log('error connecting', err);
           }
        });
    }

    query(sql: string){
        this.connection.query(sql, function(err, results, fields) {      
            
                console.log(JSON.parse(JSON.stringify(results)));
                //return JSON.parse(JSON.stringify(results));
            });
        }
    }