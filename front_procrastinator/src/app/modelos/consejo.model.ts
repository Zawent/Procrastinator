import { Nivel } from "./nivel.model";


export class Consejo {

    id?: number;
    nivel_id: Nivel;
    consejo: string | null | undefined;

    
    constructor(id: number,nivel_id: Nivel, consejo: string){
        this.id = id;
        this.nivel_id = nivel_id;
        this.consejo = consejo;
    }
}
