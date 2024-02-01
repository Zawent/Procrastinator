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
import { ConsejoService } from '../../servicios/consejo.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-create',
  standalone: true,
  imports: [CommonModule, MatInputModule,FormsModule, MatFormFieldModule, MatButtonModule, MatDividerModule, MatIconModule, MatCardModule, ReactiveFormsModule],
  providers: [ConsejoService],
  templateUrl: './create.component.html',
  styleUrl: './create.component.scss'
})
export class CreateComponent {
  consejoform = this.fb.group({
    id_nivel: null,
    consejo: '',
  })

  id: string | null;

  constructor(private fb: FormBuilder, private _router: Router, private consejoservicio: ConsejoService, private aRoute: ActivatedRoute) {
    this.id = this.aRoute.snapshot.paramMap.get('id');
  }

  ngOnInit(): void {
    this.verEditar();
  }

  verEditar(): void {
    if (this.id != null) {
      this.consejoservicio.getConsejo(this.id).subscribe(
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
      this.consejoservicio.updateConsejo(this.id, consejo).subscribe(
        data =>{
          this._router.navigate(['/consejo/index']);
        },
        error =>{
          console.log(error);
          this._router.navigate(['/consejo/index']);
        }
      )
    } else {
      this.consejoservicio.addConsejo(consejo).subscribe(
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
