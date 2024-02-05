export class User {
    id?:number;
    name:string | null | undefined;
    email:string | null | undefined;

    constructor(id:number, name:string, email:string){
        this.id = id;
        this.name = name;
        this.email = email;
    }
}
