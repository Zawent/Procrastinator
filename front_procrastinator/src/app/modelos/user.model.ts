export class User {
    id?:number;
    name:string | null | undefined;
    email:string | null | undefined;
    fecha_nacimiento: Date;
    ocupacion:string | null | undefined;
    id_rol:number;
    nivel_id:number;

    constructor(id:number, name:string, email:string, fecha_nacimiento: Date, ocupacion:string, id_rol:number, nivel_id:number){
        this.id = id;
        this.name = name;
        this.email = email;
        this.fecha_nacimiento = fecha_nacimiento;
        this.ocupacion = ocupacion;
        this.id_rol = id_rol;
        this.nivel_id = nivel_id;
    }
}
