export class Pregunta {

    id?: number;
    descripcion_pregunta: string | null | undefined;

    constructor(id:number, descripcion_pregunta:string){
        this.id = id;
        this.descripcion_pregunta = descripcion_pregunta;
    }
}
