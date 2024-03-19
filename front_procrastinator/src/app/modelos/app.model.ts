import { User } from "./user.model";


export class App {

    id?: number;
    nombre: string | null | undefined;
    id_user: User;
    

    
    constructor(id: number,id_user: User, nombre: string){
        this.id = id;
        this.nombre = nombre;
        this.id_user = id_user;
    }
}