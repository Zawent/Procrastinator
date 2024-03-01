import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import {Observable} from 'rxjs';
//import { User } from '../modelos/user.model';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  url = 'http://localhost:8000/api/auth/user/';

  constructor(private http: HttpClient) {}

  private CreacionHeaders (access_token:any): HttpHeaders{ //para la creacion de los header y que sea autortizado
    return new HttpHeaders ({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    })
  }

  getUsuarios(access_token:any): Observable<any> {
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url, options);
  }

  getUsuario(id: string, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url+id, options);
  }

  deleteUsuario(id: string,  access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.delete(this.url+id, options);
  }
}
