import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { User } from '../modelos/user.model';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {

  constructor (private _router: Router){}

  clave: string | null = null;
  usuario: User | null = null;

  
  ngOnInit(): void{
    this.validartoken();
    }
  
    ngOnchanges(): void{
      console.log("paso changes");
    }

    validartoken(): void {
      if(this.clave==null){
        this.clave=localStorage.getItem("clave");
      }if(!this.clave){
        this._router.navigate(['']);
      }
    }
}
