import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserService } from '../../servicios/user.service';
import { RolService } from '../../servicios/rol.service';
import { Router } from '@angular/router';
import { User } from '../../modelos/user.model';
import { Rol } from '../../modelos/rol.model';
import { ActivatedRoute } from '@angular/router';
import Swal from 'sweetalert2'

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [CommonModule],
  providers: [UserService, RolService],
  templateUrl: './index.component.html',
  styleUrl: './index.component.scss'
})
export class IndexComponent {
listaRol: Rol[] = [];
listaUsuarios: User[] = [];
clave: string | null = null;
usuario: User | null = null;
id: string | null;

  constructor (private userService: UserService, private rolService: RolService ,private _router: Router, private aRoute: ActivatedRoute){
    this.id = this.aRoute.snapshot.paramMap.get('id')}

  ngOnInit(): void{
    this.validartoken();
    this.cargarUsuarios();
    this.cargarRol();
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

  cargarRol():void{
    this.rolService.getRol(this.clave).subscribe(
      data1 =>{
        this.listaRol = data1;
      },
      err => {
        console.log(err);
      });
  }

  mensajeSiono(text: string, deleteText: string, id: any, confirmButtonText?: string, timer?: number) {
    Swal.fire({
      title: "¿Estás seguro de eliminar el usuario?",
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
          text: "El usuario ha sido borrado",
          icon: "success"
        });
          this.eliminarUser(id);
      }
    });
  }

  mensajeError(){
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No puedes eliminar el usuario administrador",
    });
  }
  
  eliminarUser(id:any): void{
    console.log(id);
    if (id >= 2){
      this.userService.deleteUsuario(id, this.clave).subscribe(
        data => {
          this.cargarUsuarios();
      },
      err => {
        console.log(err);
        });
    }else{
      this.mensajeError();
      console.log("no puede eliminar el usuario administrador")
    }
    
    }

    verApps(id:any): void{
      this._router.navigateByUrl("/app/index/"+id);
  }
}
