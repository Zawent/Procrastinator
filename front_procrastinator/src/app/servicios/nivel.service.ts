import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Nivel } from '../modelos/nivel.model';
import {Observable} from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NivelService {

  url = 'http://localhost:8000/api/nivel/';

  constructor(private http: HttpClient) { }
  getNiveles(access_token:any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    });
    const options= { headers: headers };
    return this.http.get(this.url, options);
  }

  addNivel(nivel: Nivel): Observable<any>{
    return this.http.post(this.url, nivel);
  }

  getNivel(id: string): Observable<any>{
    return this.http.get(this.url+id);
  }

  updateNivel(id: string, nivel: Nivel): Observable <any>{
    console.log(nivel);
    return this.http.put(this.url+id, nivel);
  }

  deleteNivel(id: string): Observable <any>{
    return this.http.delete(this.url+id);
  }
}
