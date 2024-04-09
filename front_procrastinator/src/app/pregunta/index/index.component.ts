import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PreguntaService } from '../../servicios/pregunta.service';
import { Pregunta } from '../../modelos/pregunta.model';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule],
  providers: [PreguntaService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
  listaPreguntas: Pregunta[] = [];
  clave: string | null = null;
  usuario: User | null = null;

  constructor(private preguntaservicio: PreguntaService, private _router: Router) { }

  /** Método que se ejecuta al iniciar el componente */
  ngOnInit(): void {
    this.validartoken();
    this.cargarPreguntas();
  }

  ngOnchanges(): void {
    console.log("paso changes");
  }

  /**Para validar el token de autenticación del usuario */
  validartoken(): void {
    if (this.clave == null) {
      this.clave = localStorage.getItem("clave");
    } if (!this.clave) {
      this._router.navigate(['/home']);
    }
  }

  /** lista para mostrar las preguntas */
  cargarPreguntas(): void {
    this.preguntaservicio.getPreguntas(this.clave).subscribe(
      data => {
        this.listaPreguntas = data;
      },
      err => {
        console.log(err);
      });
  }

  /** para editar las preguntas */
  editarPregunta(id: any): void {
    console.log(id);
    this._router.navigateByUrl("/pregunta/editar/" + id);
  }
}
