import { Nivel } from "./nivel.model";


export class Consejo {

    id?: number;
    id_nivel: Nivel;
    consejo: string | null | undefined;

    
    constructor(id: number,id_nivel: Nivel, consejo: string){
        this.id = id;
        this.id_nivel = id_nivel;
        this.consejo = consejo;
    }
}
