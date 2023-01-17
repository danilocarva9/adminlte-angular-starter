import { inject, Injectable } from "@angular/core";

@Injectable()

export abstract class Constants {
    static readonly API_ENDPOINT: string = 'http://localhost:8000/';
    static readonly API_NAME: string = 'App';
}