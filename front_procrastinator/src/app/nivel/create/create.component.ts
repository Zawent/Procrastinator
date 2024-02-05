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
import { Nivel } from '../../modelos/nivel.model';
import { NivelService} from '../../servicios/nivel.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-create',
  standalone: true,
  imports: [CommonModule, MatInputModule,FormsModule, MatFormFieldModule, MatButtonModule, MatDividerModule, MatIconModule, MatCardModule, ReactiveFormsModule],
  providers: [NivelService],
  templateUrl: './create.component.html',
  styleUrl: './create.component.scss'
})
export class CreateComponent {
  nivelform = this.fb.group({
    descripcion: '',
  })

  id: string | null;

  constructor(private fb: FormBuilder, private _router: Router, private nivelservicio: NivelService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

  ngOnInit(): void {
    this.verEditar();
  }

  verEditar(): void {
    if (this.id != null) {
      this.nivelservicio.getNivel(this.id).subscribe(
        data => {
          this.nivelform.setValue({
            descripcion: data.descripcion
          });
        },
        error => {
          console.log(error);
        }
      );
    }
  }

  agregarNivel(): void {
    const nivel: Nivel = {
      descripcion: this.nivelform.get('descripcion')?.value,
    }
    if (this.id != null) {
      this.nivelservicio.updateNivel(this.id, nivel).subscribe(
        data =>{
          this._router.navigate(['/nivel/index']);
        },
        error =>{
          console.log(error);
          this._router.navigate(['/nivel/index']);
        }
      )
    } else {
      this.nivelservicio.addNivel(nivel).subscribe(
        data => {
        console.log(data);
        this._router.navigate(['/nivel/index']);
      },
        err => {
          console.log(err);
          this._router.navigate(['/nivel/index']);
        });
    }

  }

}
