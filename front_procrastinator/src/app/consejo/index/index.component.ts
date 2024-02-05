import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ConsejoService } from '../../servicios/consejo.service';
import { Consejo } from '../../modelos/consejo.model';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule],
  providers: [ConsejoService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
listaConsejos: Consejo[] = [];
clave: string | null = null;
usuario: User | null = null;

  constructor (private consejoService: ConsejoService, private _router: Router){}
  
  ngOnInit(): void{
    this.validartoken();
    this.cargarConsejos();
    }
  
    ngOnchanges(): void{
      console.log("paso changes");
    }

    validartoken(): void {
      if(this.clave==null){
        this.clave=localStorage.getItem("clave");
      }if(!this.clave){
        this._router.navigate(['/inicio/body']);
      }
    }

  cargarConsejos():void{
    this.consejoService.getConsejos(this.clave).subscribe(
      data =>{
        this.listaConsejos = data;
      },
      err => {
        console.log(err);
      });
  }
  
  eliminarConsejo(id:any): void{
    console.log(id);
    this.consejoService.deleteConsejo(id).subscribe(
      data => {
        this.cargarConsejos();
    },
    err => {
      console.log(err);
      });
    }
  
    editarConsejo(id:any): void{
      this._router.navigateByUrl("/consejo/editar/"+id);
  }
}
