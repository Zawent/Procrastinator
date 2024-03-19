import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Rol } from '../modelos/rol.model';
import {Observable} from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class RolService {

  url = 'http://localhost:8000/api/app/';

  constructor(private http: HttpClient) { }

  private CreacionHeaders (access_token:any): HttpHeaders{ //para la creacion de los header y que sea autortizado
    return new HttpHeaders ({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    })
  }

  getRol(access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url, options);
  }
}
