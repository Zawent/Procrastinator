import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AppService } from '../../servicios/app.service';
import { App } from '../../modelos/app.model';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';
import {MatIconModule} from '@angular/material/icon';
import {MatDividerModule} from '@angular/material/divider';
import {MatButtonModule} from '@angular/material/button';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule, MatButtonModule, MatDividerModule, MatIconModule],
  providers: [AppService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
  listaApps: App[] = []; //lista para donde se almacena las aplicaciones del usuario
  clave: string | null = null;
  usuario: User | null = null;

  id: string | null;

  constructor (private fb: FormBuilder, private _router: Router, private appServicio: AppService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');}

    // Método que se ejecuta al iniciar el componente
  ngOnInit(): void{
    this.validartoken();
    this.cargarApps();
    }

    //para validar el token de autenticación del usuario
    validartoken(): void {
      if(this.clave==null){
        this.clave=localStorage.getItem("clave");
      }if(!this.clave){
        this._router.navigate(['/inicio/body']);
      }
    }

    //carga las apps de acuerdo al id del usuario
    cargarApps():void{
      if (this.id != null) {
        this.appServicio.getApp(this.id, this.clave).subscribe(
          data => {
            this.listaApps = data;
          },
          error => {
            console.log(error);
          }
        );
      }
    }
}
