import { Routes } from '@angular/router';
import { BodyComponent } from './incio/body/body.component';
import { IndexComponent } from './consejo/index/index.component';
import { CreateComponent } from './consejo/create/create.component';
import { HomeComponent } from './home/home.component';
import { CreateComponent as nivelcreate } from './nivel/create/create.component';
import { IndexComponent as nivelindex} from './nivel/index/index.component';
import { UpdateComponent as preguntaupdate } from './pregunta/update/update.component';
import { IndexComponent as preguntaindex} from './pregunta/index/index.component';
import { IndexComponent as userindex} from './user/index/index.component';

export const routes: Routes = [
    { path: '',redirectTo: 'inicio/body', pathMatch: 'full'},
    { path: 'inicio/body', component: BodyComponent},
    { path: 'consejo/index', component: IndexComponent},
    { path: 'consejo/create', component: CreateComponent},
    { path: 'consejo/editar/:id', component: CreateComponent},
    { path: 'home', component: HomeComponent},
    { path: 'nivel/index', component: nivelindex},
    { path: 'nivel/create', component: nivelcreate},
    { path: 'nivel/editar/:id', component: nivelcreate},
    { path: 'pregunta/index', component: preguntaindex},
    { path: 'pregunta/editar/:id', component: preguntaupdate},
    { path: 'user/index', component: userindex}
];
