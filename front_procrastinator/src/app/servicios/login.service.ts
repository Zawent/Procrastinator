import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
    url = 'https://procras.api.adsocidm.com/api/auth/';

  constructor(private http:HttpClient) { }

  login(email:any, password:any):Observable<any>{
    return this.http.post(this.url+"login", {email:email, password:password});
  }
  logout():Observable<any>{
    return this.http.post(this.url+"logout",null);
  }
}
