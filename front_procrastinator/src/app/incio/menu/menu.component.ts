import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';



@Component({
  selector: 'app-menu',
  standalone: true,
  imports: [CommonModule, MatButtonModule],
  templateUrl: './menu.component.html',
  styleUrl: './menu.component.scss'
})
export class MenuComponent {

  clave: string | null = null;
  logueando: boolean = false;
  flag: boolean = false;

  constructor(private router: Router) { }

  /** Método que se ejecuta al iniciar el componente */
  ngOnInit(): void {
    this.getClave();
  }

  /** para verificar si esta logueado y salga el boton de cerrar sesion */
  getClave(): void {
    this.clave = localStorage.getItem('clave');
    if (this.clave != null) {
      this.logueando = true;
      this.flag = true;
    }
  }

  /** para poder cerrar sesion */
  logout(): void {
    localStorage.clear();
    location.reload();
    this.logueando = false
    this.flag = true;
    window.location.reload();
  }

}
