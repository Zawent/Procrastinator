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

  private CreacionHeaders (access_token:any): HttpHeaders{ //para la creacion de los header y que sea autortizado
    return new HttpHeaders ({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    })
  }
  
    getPreguntas(access_token:any): Observable<any> {
      const options= { headers: this.CreacionHeaders(access_token) };
      return this.http.get(this.url, options);
   }

  getPregunta(id: string, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url+id, options);
  }

  updatePregunta(id: string, pregunta: Pregunta, access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    console.log(pregunta);
    return this.http.put(this.url+id, pregunta, options);
  }
}
