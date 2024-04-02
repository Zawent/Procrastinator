import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Nivel } from '../modelos/nivel.model';
import {Observable} from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NivelService {

  url = 'https://procras.api.adsocidm.com/api/nivel';

  constructor(private http: HttpClient) { }

  private CreacionHeaders (access_token:any): HttpHeaders{ //para la creacion de los header y que sea autortizado
    return new HttpHeaders ({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    })
  }

  getNiveles(access_token:any): Observable<any> {
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url, options);
  }

  addNivel(nivel: Nivel, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.post(this.url, nivel, options);
  }

  getNivel(id: string, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url+"/"+id, options);
  }

  updateNivel(id: string, nivel: Nivel, access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    console.log(nivel);
    return this.http.put(this.url+"/"+id, nivel, options);
  }

  deleteNivel(id: string, access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.delete(this.url+"/"+id, options);
  }
}
