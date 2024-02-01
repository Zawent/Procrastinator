import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Login } from '../modelos/login.model';

@Component({
  selector: 'app-global',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './global.component.html',
  styleUrl: './global.component.scss'
})
export class GlobalComponent {

  public static respuesta: Login | null=null;
}
