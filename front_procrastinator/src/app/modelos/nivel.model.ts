export class Nivel {

    id?: number;
    descripcion: string | null | undefined;

    constructor(id:number, descripcion:string){
        this.id = id;
        this.descripcion = descripcion;
    }
}
