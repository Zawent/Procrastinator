import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NivelService } from '../../servicios/nivel.service';
import { Nivel } from '../../modelos/nivel.model';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule],
  providers: [NivelService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
  listaNiveles: Nivel[] = [];
  clave: string | null = null;
  usuario: User | null = null;
  
    constructor (private nivelservicio: NivelService, private _router: Router){}
    
    ngOnInit(): void{
      this.validartoken();
      this.cargarNiveles();
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
  
      //carga los niveles para colocarlos en la lista
      cargarNiveles():void{
      this.nivelservicio.getNiveles(this.clave).subscribe(
        data =>{
          this.listaNiveles = data;
        },
        err => {
          console.log(err);
        });
    }
    
    //elimina los niveles 
    eliminarNivel(id:any): void{
      console.log(id);
      this.nivelservicio.deleteNivel(id, this.clave).subscribe(
        data => {
          this.cargarNiveles();
      },
      err => {
        console.log(err);
        });
      }
    
      //edita niveles
      editarNivel(id:any): void{
        console.log(id);
        this._router.navigateByUrl("/nivel/editar/"+id);
    }
}
