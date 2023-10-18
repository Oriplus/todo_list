import axios from "axios";

const DEFAULT_URL = "/api/tasks";

/**
 * Fetch all tasks.
 *
 * @returns {Promise<Object>} Returns the tasks data.
 * @throws {Error} Throws an error if there's an issue fetching the tasks.
 */
export async function fetch() {
    try {
        const response = await axios.get(DEFAULT_URL);
        return response.data;
    } catch (error) {
        throw error;
    }
}

/**
 * Store a new task.
 *
 * @param {Object} data - The task data to be stored.
 * @returns {Promise<Object>} Returns the saved task data.
 * @throws {Error} Throws an error if there's an issue storing the task.
 */
export async function store(data) {
    try {
        const response = await axios.post(DEFAULT_URL, data);
        return response.data;
    } catch (error) {
        throw error;
    }
}

/**
 * Delete a task.
 *
 * @param {number} id - The ID of the task to be deleted.
 * @returns {Promise<Object>} Returns the response data.
 * @throws {Error} Throws an error if there's an issue deleting the task.
 */
export async function destroy(id) {
    try {
        const response = await axios.delete(`${DEFAULT_URL}/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
}

/**
 * Update a task.
 *
 * @param {number} id - The ID of the task to be updated.
 * @param {Object} data - The updated task data.
 * @param {string} [method="PUT"] - The HTTP method to use (either "PUT" or "PATCH").
 * @param {string} [customUrl=''] - A custom URL endpoint, if needed.
 * @returns {Promise<Object>} Returns the updated task data.
 * @throws {Error} Throws an error if there's an issue updating the task.
 */
export async function update(id, data, method = "PUT", customUrl= '') {
    const endpoint =`${DEFAULT_URL}/${id}${customUrl}`;
    try {
        let response;
        if (method === "PUT") {
            response = await axios.put(endpoint, data);
        } else if (method === "PATCH") {
            response = await axios.patch(endpoint, data);
        }
        return response.data;
    } catch (error) {
        throw error;
    }
}
