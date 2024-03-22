import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Consejo } from '../modelos/consejo.model';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConsejoService {

  url = 'https://procras.api.adsocidm.com/api/consejo';

  constructor(private http: HttpClient) { }

  private CreacionHeaders (access_token:any): HttpHeaders{ //para la creacion de los header y que sea autortizado
    return new HttpHeaders ({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    })
  }

  getConsejos(access_token:any): Observable<any> {
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url, options);
  }

  addConsejo(consejo: Consejo, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    console.log("consejo", consejo);
    return this.http.post(this.url, consejo, options);
  }

  getConsejo(id: string, access_token:any): Observable<any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.get(this.url+"/"+id, options);
  }

  updateConsejo(id: string, consejo: Consejo, access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.put(this.url+"/"+id, consejo, options);
  }

  deleteConsejo(id: string, access_token:any): Observable <any>{
    const options= { headers: this.CreacionHeaders(access_token) };
    return this.http.delete(this.url+"/"+id, options);
  }
}
