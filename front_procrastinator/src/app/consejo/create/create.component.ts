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
import { Consejo } from '../../modelos/consejo.model';
import { Nivel } from '../../modelos/nivel.model';
import { ConsejoService } from '../../servicios/consejo.service';
import { NivelService } from '../../servicios/nivel.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import {MatSelectModule} from '@angular/material/select';
import { User } from '../../modelos/user.model';

@Component({
  selector: 'app-create',
  standalone: true,
  imports: [CommonModule, MatInputModule,FormsModule, MatFormFieldModule, MatButtonModule, MatDividerModule, MatIconModule, MatCardModule, ReactiveFormsModule, MatSelectModule],
  providers: [ConsejoService, NivelService],
  templateUrl: './create.component.html',
  styleUrl: './create.component.scss'
})
export class CreateComponent {
  listaniveles: Nivel[] = []; //para poder listar los niveles
  clave: string | null = null;
  usuario: User | null = null;
  consejoform = this.fb.group({//formulario para los datos del consejo
    id_nivel: null,
    consejo: '',
  })

  id: string | null;

  constructor(private fb: FormBuilder, private _router: Router, private consejoservicio: ConsejoService, private nivelservicio: NivelService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

    // Método que se ejecuta al iniciar el componente
  ngOnInit(): void {
    this.validartoken();
    this.verEditar();
    this.verNiveles();
  }

  //para validar el token de autenticación del usuario
  validartoken(): void {
    if(this.clave==null){
      this.clave=localStorage.getItem("clave");
    }if(!this.clave){
      this._router.navigate(['/inicio/body']);
    }
  }

  //para poder mostrar los niveles en una lista escogible
  verNiveles():void{
    this.nivelservicio.getNiveles(this.clave).subscribe(
      data => {
        this.listaniveles = data;
      },
      err => {
        console.log(err);
      });
  }

  //donde al momento de actualizar un consejo y aparezca los datos que esten para editar
  verEditar(): void {
    if (this.id != null) {
      this.consejoservicio.getConsejo(this.id, this.clave).subscribe(
        data => {
          this.consejoform.setValue({
            id_nivel: data.id_nivel,
            consejo: data.consejo
          });
        },
        error => {
          console.log(error);
        }
      );
    }
  }

  // para poder crear o actualizar un consejo
  agregarConsejo(): void {
    const consejo: Consejo = {
      id_nivel: this.consejoform.get('id_nivel')?.value!,
      consejo: this.consejoform.get('consejo')?.value,
    }
    //aqui es donde el id es diferente a null actualice el consejo y se guarde esos cambios
    if (this.id != null) {
      this.consejoservicio.updateConsejo(this.id, consejo, this.clave).subscribe(
        data =>{
          this._router.navigate(['/consejo/index']);
        },
        error =>{
          console.log(error);
          this._router.navigate(['/consejo/index']);
        }
      )
    } else {
      //aqui es para crear un consejo nuevo porque el id es null
      this.consejoservicio.addConsejo(consejo, this.clave).subscribe(
        data => {
        console.log(data);
        this._router.navigate(['/consejo/index']);
      },
        err => {
          console.log(err);
          this._router.navigate(['/consejo/index']);
        });
    }

  }
}
