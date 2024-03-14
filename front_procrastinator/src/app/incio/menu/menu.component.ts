import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import {MatButtonModule} from '@angular/material/button';



@Component({
  selector: 'app-menu',
  standalone: true,
  imports: [CommonModule, MatButtonModule],
  templateUrl: './menu.component.html',
  styleUrl: './menu.component.scss'
})
export class MenuComponent {

  clave: string |null=null;
  logueando: boolean = false;
  flag: boolean = false;

  constructor(private router: Router){}

  ngOnInit(): void {
    this.getClave();
  }

  getClave(): void{
    //if(this.clave==localStorage.getItem('clave')!=null){
      this.clave=localStorage.getItem('clave');
      //console.log(this.clave);
      if (this.clave!=null) {
        this.logueando=true;
        this.flag=true;
        //console.log("paso");
      }
    //}
  }

  logout():void{
    localStorage.clear();
    location.reload();
    //this.router.navigate(['']);
    this.logueando = false
    this.flag=true;
    window.location.reload();
  }

}
