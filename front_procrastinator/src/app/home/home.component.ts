import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { User } from '../modelos/user.model';
import { MatIconModule } from '@angular/material/icon';
import { MatDividerModule } from '@angular/material/divider';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [MatButtonModule, MatDividerModule, MatIconModule],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {

  constructor(private _router: Router) { }

  clave: string | null = null;
  usuario: User | null = null;

  /** Método que se ejecuta al iniciar el componente */
  ngOnInit(): void {
    this.validartoken();
  }

  ngOnchanges(): void {
    console.log("paso changes");
  }

  /** para validar el token de autenticación del usuario */
  validartoken(): void {
    if (this.clave == null) {
      this.clave = localStorage.getItem("clave");
    } if (!this.clave) {
      this._router.navigate(['inicio/body']);
    }
  }
}
