import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserService } from '../../servicios/user.service';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule],
  providers: [UserService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
listaUsuarios: User[] = [];
clave: string | null = null;
usuario: User | null = null;

  constructor (private userService: UserService, private _router: Router){}

  ngOnInit(): void{
    this.validartoken();
    this.cargarUsuarios();
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

  cargarUsuarios():void{
    this.userService.getUsuarios(this.clave).subscribe(
      data =>{
        this.listaUsuarios = data;
      },
      err => {
        console.log(err);
      });
  }
  
  eliminarUser(id:any): void{
    console.log(id);
    this.userService.deleteUsuario(id, this.clave).subscribe(
      data => {
        this.cargarUsuarios();
    },
    err => {
      console.log(err);
      });
    }

}
