import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ConsejoService } from '../../servicios/consejo.service';
import { Consejo } from '../../modelos/consejo.model';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';
import { MatIconModule } from '@angular/material/icon';
import { MatDividerModule } from '@angular/material/divider';
import { MatButtonModule } from '@angular/material/button';
import { ActivatedRoute } from '@angular/router';
import Swal from 'sweetalert2'

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule, MatButtonModule, MatDividerModule, MatIconModule],
  providers: [ConsejoService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
  listaConsejos: Consejo[] = [];//lista los consejos
  clave: string | null = null;
  usuario: User | null = null;

  id: string | null;

  constructor(private consejoService: ConsejoService, private _router: Router, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

  /** Método que se ejecuta al iniciar el component */
  ngOnInit(): void {
    this.validartoken();
    this.cargarConsejos();
  }

  ngOnchanges(): void {
    console.log("paso changes");
  }

  /** Para validar el token de autenticación del usuario */
  validartoken(): void {
    if (this.clave == null) {
      this.clave = localStorage.getItem("clave");
    } if (!this.clave) {
      this._router.navigate(['/inicio/body']);
    }
  }

  /** ver los consejos en la tabla */
  cargarConsejos(): void {
    this.consejoService.getConsejos(this.clave).subscribe(
      data => {
        this.listaConsejos = data;
      },
      err => {
        console.log(err);
      });
  }

  /** es una alerta para estar seguro del usuario de eliminar ese consejo */
  mensajeSiono(text: string, deleteText: string, id: any, confirmButtonText?: string, timer?: number) {
    Swal.fire({
      title: "¿Estás seguro de eliminar el consejo?",
      text: "¡No podrás revertir este cambio!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Borrado",
          text: "El consejo ha sido borrado",
          icon: "success"
        });
        this.eliminarConsejo(id);
      }
    });
  }

  /** es un mensaje para cuando de error */
  mensajeError() {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No puedes eliminar todos los consejos del mismo nivel",
    });
  }

  /** para eliminar un consejo por id */
  eliminarConsejo(id: any): void {
    console.log(id);
    this.consejoService.deleteConsejo(id, this.clave).subscribe(
      data => {
        this.cargarConsejos();
      },
      err => {
        this.mensajeError();
        console.log(err);
      });
  }

  /** envia a la siguiente pestaña para editar el consejo enviandole el id del consejo */
  editarConsejo(id: any): void {
    this._router.navigateByUrl("/consejo/editar/" + id);
  }
}
