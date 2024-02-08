import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import {Observable} from 'rxjs';
import { Injectable } from '@angular/core';
import { Pregunta } from '../modelos/pregunta.model';

@Injectable({
  providedIn: 'root'
})
export class PreguntaService {

  url = 'http://localhost:8000/api/pregunta/';

  constructor(private http: HttpClient) {}
    getPreguntas(access_token:any): Observable<any> {
      const headers = new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + access_token
      });
      const options= { headers: headers };
      return this.http.get(this.url, options);
   }

  getPregunta(id: string): Observable<any>{
    return this.http.get(this.url+id);
  }

  updatePregunta(id: string, pregunta: Pregunta): Observable <any>{
    console.log(pregunta);
    return this.http.put(this.url+id, pregunta);
  }
}
