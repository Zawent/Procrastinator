import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LoginService } from '../../servicios/login.service';
import { Login } from '../../modelos/login.model';
import { GlobalComponent } from '../../global/global.component';
import { User } from '../../modelos/user.model';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-body',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  providers: [LoginService],
  templateUrl: './body.component.html',
  styleUrl: './body.component.scss'
})
export class BodyComponent {

  loginForm = this.fb.group({
    username: '',
    password: ''
  });

  respuesta: Login | null = null;
  clave: string | null = null;
  usuario: User | null = null;

  constructor(private fb: FormBuilder,
    private loginService: LoginService,
    private router: Router) { }

  ngOnInit():void {}

  ngOnChanges(): void {
    this.clave = localStorage.getItem('clave');
    if (GlobalComponent.respuesta!=null){
      this.router.navigate(['/ficha/index']);
    }
  }


  login(): void {
    //console.log(this.loginForm.get('username')?.value);
    //console.log(this.loginForm.get('password')?.value);
    this.loginService.login(this.loginForm.get('username')?.value,
      this.loginForm.get('password')?.value).subscribe(
        rs => {
          this.respuesta = rs;
          //console.log(this.respuesta?.user);
          //this.router.navigate(['ficha/index']);
          if (this.respuesta != null) {
            GlobalComponent.respuesta = this.respuesta;
            localStorage.setItem("clave",this.respuesta.access_token);
            this.router.navigate(['/home/']);
          }
        },
        err => {
          console.log(err);
        }
      )
  }
}
