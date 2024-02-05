import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Consejo } from '../modelos/consejo.model';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConsejoService {

  url = 'http://localhost:8000/api/consejo/';

  constructor(private http: HttpClient) { }
  getConsejos(access_token:any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + access_token
    });
    const options= { headers: headers };
    return this.http.get(this.url, options);
  }

  addConsejo(consejo: Consejo): Observable<any>{
    return this.http.post(this.url, consejo);
  }

  getConsejo(id: string): Observable<any>{
    return this.http.get(this.url+id);
  }

  updateConsejo(id: string, consejo: Consejo): Observable <any>{
    return this.http.put(this.url+id, consejo);
  }

  deleteConsejo(id: string): Observable <any>{
    return this.http.delete(this.url+id);
  }
}
