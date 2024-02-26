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
  listaniveles: Nivel[] = [];
  clave: string | null = null;
  usuario: User | null = null;
  consejoform = this.fb.group({
    id_nivel: null,
    consejo: '',
  })

  id: string | null;

  constructor(private fb: FormBuilder, private _router: Router, private consejoservicio: ConsejoService, private nivelservicio: NivelService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

  ngOnInit(): void {
    this.validartoken();
    this.verEditar();
    this.verNiveles();
  }

  validartoken(): void {
    if(this.clave==null){
      this.clave=localStorage.getItem("clave");
    }if(!this.clave){
      this._router.navigate(['/inicio/body']);
    }
  }

  verNiveles():void{
    this.nivelservicio.getNiveles(this.clave).subscribe(
      data => {
        this.listaniveles = data;
      },
      err => {
        console.log(err);
      });
  }

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

  agregarConsejo(): void {
    const consejo: Consejo = {
      id_nivel: this.consejoform.get('id_nivel')?.value!,
      consejo: this.consejoform.get('consejo')?.value,
    }
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
