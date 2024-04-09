import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatFormFieldModule } from '@angular/material/form-field';
import { FormsModule } from '@angular/forms';
import { MatInputModule } from '@angular/material/input';
import { MatIconModule } from '@angular/material/icon';
import { MatDividerModule } from '@angular/material/divider';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { Pregunta } from '../../modelos/pregunta.model';
import { PreguntaService } from '../../servicios/pregunta.service';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-update',
  standalone: true,
  imports: [CommonModule, MatInputModule, FormsModule, MatFormFieldModule, MatButtonModule, MatDividerModule, MatIconModule, MatCardModule, ReactiveFormsModule],
  providers: [PreguntaService],
  templateUrl: './update.component.html',
  styleUrl: './update.component.scss'
})
export class UpdateComponent {
  clave: string | null = null;
  usuario: User | null = null;
  preguntaform = this.fb.group({
    descripcion_pregunta: '',
  })

  id: string | null;

  constructor(private fb: FormBuilder, private _router: Router, private preguntaservicio: PreguntaService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

  /** Método que se ejecuta al iniciar el componente */
  ngOnInit(): void {
    this.validartoken();
    this.verEditar();
  }

  /** Para validar el token de autenticación del usuario **/
  validartoken(): void {
    if (this.clave == null) {
      this.clave = localStorage.getItem("clave");
    } if (!this.clave) {
      this._router.navigate(['/home']);
    }
  }

  /** donde al momento de actualizar una pregunta y aparezca los datos que esten para editar */
  verEditar(): void {
    if (this.id != null) {
      this.preguntaservicio.getPregunta(this.id, this.clave).subscribe(
        data => {
          this.preguntaform.setValue({
            descripcion_pregunta: data.descripcion_pregunta
          });
        },
        error => {
          console.log(error);
        }
      );
    }
  }

  /** para que se guarde la actualizacion de esa pregunta */
  actualizarPregunta(): void {
    const pregunta: Pregunta = {
      descripcion_pregunta: this.preguntaform.get('descripcion_pregunta')?.value,
    }
    if (this.id != null) {
      this.preguntaservicio.updatePregunta(this.id, pregunta, this.clave).subscribe(
        data => {
          this._router.navigate(['/pregunta/index']);
        },
        error => {
          console.log(error);
          this._router.navigate(['/pregunta/index']);
        }
      )
    }
  }

}
