import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LoginService } from '../../servicios/login.service';
import { Login } from '../../modelos/login.model';
import { GlobalComponent } from '../../global/global.component';
import { User } from '../../modelos/user.model';
import { MatCardModule } from '@angular/material/card';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
//imports de angular material 
import { FormControl, Validators, FormsModule } from '@angular/forms';
import { MatInputModule } from '@angular/material/input';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-body',
  standalone: true,
  imports: [CommonModule, MatFormFieldModule, MatInputModule, FormsModule, ReactiveFormsModule, MatButtonModule, MatIconModule, MatCardModule],
  providers: [LoginService],
  templateUrl: './body.component.html',
  styleUrl: './body.component.scss'
})
export class BodyComponent {
  hide = true;
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

  /** comprobacion de que la persona se haya registrado */
  ngOnInit(): void {
    this.clave = localStorage.getItem('clave');
    if (this.clave) {
      this.router.navigate(['/home/']);
    }
  }

  /** para poder iniciar sesion */
  login(): void {
    this.loginService.login(this.loginForm.get('username')?.value,
      this.loginForm.get('password')?.value).subscribe(
        rs => {
          this.respuesta = rs;
          if (this.respuesta != null) {
            if (this.respuesta.user.id_rol != 2) {
              GlobalComponent.respuesta = this.respuesta;
              localStorage.setItem("clave", this.respuesta.access_token);
              window.location.reload();
            } else {
              console.log('No estas autorizado');
            }
          }
        },
        err => {
          console.log(err);
        }
      )
  }


}
