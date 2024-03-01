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
  logueando: boolean = true;

  constructor(private router: Router){}

  ngOninit(): void {
    if(this.clave==null){
      this.clave=localStorage.getItem('clave');
    }
  }

  logout():void{
    localStorage.clear();
    location.reload();
    this.router.navigate(['']);
    this.logueando = false
  }

}
