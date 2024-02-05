import { Routes } from '@angular/router';
import { BodyComponent } from './incio/body/body.component';
import { IndexComponent } from './consejo/index/index.component';
import { CreateComponent } from './consejo/create/create.component';
import { HomeComponent } from './home/home.component';
import { CreateComponent as nivelcreate } from './nivel/create/create.component';
import { IndexComponent as nivelindex} from './nivel/index/index.component';

export const routes: Routes = [
    { path: '',redirectTo: 'inicio/body', pathMatch: 'full'},
    { path: 'inicio/body', component: BodyComponent},
    { path: 'consejo/index', component: IndexComponent},
    { path: 'consejo/create', component: CreateComponent},
    { path: 'consejo/editar/:id', component: CreateComponent},
    { path: 'home', component: HomeComponent},
    { path: 'nivel/index', component: nivelindex},
    { path: 'nivel/create', component: nivelcreate},
    { path: 'nivel/editar/:id', component: nivelcreate}
];
