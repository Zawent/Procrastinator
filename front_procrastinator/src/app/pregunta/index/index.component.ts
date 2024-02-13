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
  
    constructor (private preguntaservicio: PreguntaService, private _router: Router){}
    
    ngOnInit(): void{
      this.validartoken();
      this.cargarPreguntas();
      }
    
      ngOnchanges(): void{
        console.log("paso changes");
      }

      validartoken(): void {
        if(this.clave==null){
          this.clave=localStorage.getItem("clave");
        }if(!this.clave){
          this._router.navigate(['/home']);
        }
      }
  
      cargarPreguntas():void{
      this.preguntaservicio.getPreguntas(this.clave).subscribe(
        data =>{
          this.listaPreguntas = data;
        },
        err => {
          console.log(err);
        });
    }

    editarPregunta(id:any): void{
      console.log(id);
      this._router.navigateByUrl("/pregunta/editar/"+id);
  }
}
