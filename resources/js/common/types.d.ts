export interface ResponseCollection<T> {
    data: Array<T>;
}

export interface Project {
    id: number;
    title: string;
    canvas_link: string;
    hits: number;
    order_pos: number;
}

export interface ProjectListResponse extends ResponseCollection<Project> {}
